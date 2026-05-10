#!/bin/bash

# Setup the local WordPress environment via REST API.

WP_URL="${WP_ENV_URL:-http://localhost:8888}"
COOKIE_JAR=$(mktemp)

echo "Running setup via REST API ($WP_URL)..."

# Pre-flight request to handle Playground auto-login redirect.
curl -s -o /dev/null -L -b "$COOKIE_JAR" -c "$COOKIE_JAR" "$WP_URL/?rest_route=/"

RESPONSE=$(curl -s -w "\n%{http_code}" -b "$COOKIE_JAR" -X POST "$WP_URL/?rest_route=/wporg-env/v1/setup")
HTTP_CODE=$(echo "$RESPONSE" | tail -1)
BODY=$(echo "$RESPONSE" | sed '$d')

rm -f "$COOKIE_JAR"

if [ "$HTTP_CODE" != "200" ]; then
	echo "Error: Setup endpoint returned HTTP $HTTP_CODE"
	echo "$BODY"
	exit 1
fi

echo "$BODY" | python3 -c "import sys,json; [print(l) for l in json.load(sys.stdin).get('log',[])]" 2>/dev/null || echo "$BODY"
