#!/bin/bash

# Setup the local WordPress environment via REST API.

WP_URL="${WP_ENV_URL:-http://localhost:8888}"

echo "Running setup via REST API ($WP_URL)..."

# Wait for WordPress to be ready (Playground may need a moment).
for i in $(seq 1 10); do
	STATUS=$(curl -s -o /dev/null -w "%{http_code}" -L "$WP_URL/?rest_route=/")
	[ "$STATUS" = "200" ] && break
	echo "Waiting for WordPress to be ready (attempt $i, status $STATUS)..."
	# Debug: show redirect location
	curl -s -o /dev/null -w "Redirect: %{redirect_url}\n" "$WP_URL/?rest_route=/"
	sleep 2
done

RESPONSE=$(curl -s -w "\n%{http_code}" -L -X POST "$WP_URL/?rest_route=/wporg-env/v1/setup")
HTTP_CODE=$(echo "$RESPONSE" | tail -1)
BODY=$(echo "$RESPONSE" | sed '$d')

if [ "$HTTP_CODE" != "200" ]; then
	echo "Error: Setup endpoint returned HTTP $HTTP_CODE"
	echo "$BODY"
	exit 1
fi

echo "$BODY" | python3 -c "import sys,json; [print(l) for l in json.load(sys.stdin).get('log',[])]" 2>/dev/null || echo "$BODY"
