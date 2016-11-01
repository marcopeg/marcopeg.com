#
# Migrate Wordpress Database
#

PRINT_FEEDBACK="yes"
for last; do true; done
if [ "--now" == "$last" ]; then
    PRINT_FEEDBACK="no"
fi

BACKUP_DELAY=${BACKUP_DELAY:-3}

if [ "" == "$WP_MIGRATE_TO" ]; then
    WP_MIGRATE_TO="http://localhost:$HUMBLE_PORT"
fi

if [ "" == "$WP_MIGRATE_FROM" ]; then
    echo "====== WP-MIGRATE ($HUMBLE_ENV) ======"
    echo "--> nothing to migrate"
    echo ""
    exit
fi

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "====== WP-MIGRATE ($HUMBLE_ENV) ======"
    echo "from: $WP_MIGRATE_FROM"
    echo "to:   $WP_MIGRATE_TO"
    echo "(sleep "$BACKUP_DELAY"s, you can abort now)"
    sleep $BACKUP_DELAY
    echo ""
    echo ""
fi

if [ "" != "WP_MIGRATE_FROM" ]; then
    for MIGRATE_FROM in $WP_MIGRATE_FROM; do
        [ "$PRINT_FEEDBACK" == "yes" ] && echo "migrate $MIGRATE_FROM -> $WP_MIGRATE_TO ..."
        humble utils wp-migrate $MIGRATE_FROM $WP_MIGRATE_TO --now >/dev/null 2>/dev/null
    done
fi

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "--> migration complete!"
    echo ""
    echo ""
fi
exit
