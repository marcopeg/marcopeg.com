#
# Environment Seeding
#

PRINT_FEEDBACK="yes"
P3=$3

for last; do true; done
if [ "--now" == "$last" ]; then
    PRINT_FEEDBACK="no"
    [ "$P3" == "$last" ] && P3=""
fi

BACKUP_DELAY=${BACKUP_DELAY:-3}
SEED_SOURCE=${P3:-$SEED_SOURCE}
if [ "" == "$SEED_SOURCE" ]; then
    SEED_SOURCE="seed-$HUMBLE_ENV"
fi

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "====== SEED ($HUMBLE_ENV) ======"
    echo "from: backup/$SEED_SOURCE"
    echo "(sleep "$BACKUP_DELAY"s, you can abort now)"
    sleep $BACKUP_DELAY
    echo ""
    echo ""
fi

echo "restore from local backup..."
humble run restore $SEED_SOURCE       --now

echo "migrate database..."
humble run wp-migrate                 --now

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "--> seeding complete!"
    echo ""
    echo ""
fi
exit
