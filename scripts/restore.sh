#
# Restore latest available backup for current environment
#

RESTORE_SOURCE=${P2:-$RESTORE_SOURCE}
if [ "" == "$RESTORE_SOURCE" ]; then
    AVAILABLE_BACKUPS=$(find $BACKUP_ROOT/$HUMBLE_ENV.* -maxdepth 0 -type d)
    for RESTORE_SOURCE in $AVAILABLE_BACKUPS; do :; done
    RESTORE_SOURCE=$(basename $RESTORE_SOURCE)
fi

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "====== RESTORE BACKUP ($HUMBLE_ENV) ======"
    echo "from: $RESTORE_SOURCE"
    enterToContinue
    echo ""
    echo ""
fi

echo "wp-uploads..."
humble do fs-seed      $RESTORE_SOURCE/wp-uploads.tar.gz     storage://var/www/html/wp-content/uploads     --now >/dev/null 2>/dev/null

echo "wp-plugins..."
humble do fs-seed      $RESTORE_SOURCE/wp-plugins.tar.gz     storage://var/www/html/wp-content/plugins     --now >/dev/null 2>/dev/null

echo "change file owner to www-data..."
humble exec wordpress chown -R www-data:www-data wp-content

echo "import database..."
humble do mysql-seed   $RESTORE_SOURCE/mysql-db.sql.gz       mysql://wordpress                             --now >/dev/null 2>/dev/null

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "--> restore complete!"
    echo ""
    echo ""
fi
exit
