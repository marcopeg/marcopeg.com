
# HUMBLE_URL
# may be defined by the environment file
if [ -z "$HUMBLE_URL" ]; then
    HUMBLE_URL=${3:-"http://localhost:$HUMBLE_PORT"}
fi

humble info

echo ""
echo ""
echo "### Tearing down existing project..."
echo ""
humble down

echo ""
echo ""
echo "### Build and boot new project..."
echo ""
humble up -d --build

echo ""
echo ""
echo "Waiting for: $HUMBLE_URL"
HTTP_DATA=$(fetch "$HUMBLE_URL")
while [ "$HTTP_DATA" == "" ]; do
    HTTP_DATA=$(fetch "$HUMBLE_URL")
    echo "Waiting for: $HUMBLE_URL"
    sleep 2.5
done

IS_WP_INSTALL=$(indexOf "$HTTP_DATA" "wp-core-ui language-chooser")
if [ "$IS_WP_INSTALL" != "-1" ]; then
    echo ""
    echo ""
    echo "Wordpress: install page detected,"
    echo "Run seeding script..."
    humble run seed
fi

echo ""
echo ""
echo "System is ready at:"
echo "$HUMBLE_URL"
sleep 5

echo ""
echo ""
echo "### Attaching to the logs:"
echo ""
humble logs -f
