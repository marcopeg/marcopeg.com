#
# Perform a Versioned Full Backup
#

BACKUP_TARGET="$HUMBLE_ENV.$BACKUP_DATE"

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "====== BACKUP ($HUMBLE_ENV) ======"
    echo "to: $BACKUP_TARGET"
    enterToContinue
    echo ""
    echo ""
fi

echo "wp-uploads..."
humble do fs-backup      storage://var/www/html/wp-content/uploads       "$BACKUP_TARGET/wp-uploads.tar.gz"        --now >/dev/null 2>/dev/null

echo "wp-plugins..."
humble do fs-backup      storage://var/www/html/wp-content/plugins       "$BACKUP_TARGET/wp-plugins.tar.gz"        --now >/dev/null 2>/dev/null

echo "database..."
humble do mysql-backup   mysql://wordpress                               "$BACKUP_TARGET/mysql-db"                 --now >/dev/null 2>/dev/null

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "--> backup complete!"
    echo ""
    echo ""
fi
exit
