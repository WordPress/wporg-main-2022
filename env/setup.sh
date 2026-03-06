#!/bin/bash

# Setup the local WordPress environment via REST API.

WP_URL="${WP_ENV_URL:-http://localhost:8888}"

echo "Running setup via REST API ($WP_URL)..."

# Debug: check what WordPress returns.
echo "Debug: REST root response:"
curl -v "$WP_URL/?rest_route=/" 2>&1 | head -30
echo ""
echo "Debug: POST to setup endpoint:"
curl -v -X POST "$WP_URL/?rest_route=/wporg-env/v1/setup" 2>&1 | head -30

RESPONSE=$(curl -s -w "\n%{http_code}" -X POST "$WP_URL/?rest_route=/wporg-env/v1/setup")
HTTP_CODE=$(echo "$RESPONSE" | tail -1)
BODY=$(echo "$RESPONSE" | sed '$d')

if [ "$HTTP_CODE" != "200" ]; then
	echo "Error: Setup endpoint returned HTTP $HTTP_CODE"
	echo "$BODY"
	exit 1
fi

echo "$BODY" | python3 -c "import sys,json; [print(l) for l in json.load(sys.stdin).get('log',[])]" 2>/dev/null || echo "$BODY"
