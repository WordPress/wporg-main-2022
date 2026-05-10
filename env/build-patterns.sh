#!/bin/bash

# Refresh pattern files from the live wordpress.org site via REST API.

THEME_DIR="source/wp-content/themes/wporg-main-2022"
MANIFEST="env/page-manifest.json"
WP_URL="${WP_ENV_URL:-http://localhost:8888}"
COOKIE_JAR=$(mktemp)

# Pre-flight request to handle Playground auto-login redirect.
curl -s -o /dev/null -L -b "$COOKIE_JAR" -c "$COOKIE_JAR" "$WP_URL/?rest_route=/"

echo "Exporting patterns via REST API ($WP_URL)..."
RESPONSE=$(curl -s -w "\n%{http_code}" -b "$COOKIE_JAR" -X POST \
	-H "Content-Type: application/json" \
	-d @"$MANIFEST" \
	"$WP_URL/?rest_route=/wporg-env/v1/export-patterns")
HTTP_CODE=$(echo "$RESPONSE" | tail -1)
BODY=$(echo "$RESPONSE" | sed '$d')

rm -f "$COOKIE_JAR"

if [ "$HTTP_CODE" != "200" ] && [ "$HTTP_CODE" != "207" ]; then
	echo "Error: Export endpoint returned HTTP $HTTP_CODE"
	echo "$BODY"
	exit 1
fi

# Write each file from the JSON response.
echo "$BODY" | python3 -c "
import sys, json, os

data = json.load(sys.stdin)

for f in data.get('files', []):
    path = '$THEME_DIR/' + f['path']
    content = f['content']
    file_type = f['type']

    # For templates, only write if file does not exist (same as original behavior).
    if file_type == 'template' and os.path.exists(path):
        print(f'Skipping {path}')
        continue

    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, 'w') as fh:
        fh.write(content)
    print(f'Wrote {len(content)} bytes to {path}')

for err in data.get('errors', []):
    print(f'!! Error: {err}')

if data.get('errors'):
    sys.exit(1)
"
