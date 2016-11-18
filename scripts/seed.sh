#
# Environment Seeding
#

SEED_SOURCE=${P2:-$SEED_SOURCE}
if [ "" == "$SEED_SOURCE" ]; then
    SEED_SOURCE="seed-$HUMBLE_ENV"
fi

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "====== SEED ($HUMBLE_ENV) ======"
    echo "from: $SEED_SOURCE"
    enterToContinue
    echo ""
    echo ""
fi

echo "restore from local backup..."
humble restore $SEED_SOURCE       --now

echo "migrate database..."
humble wp-migrate                 --now

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "--> seeding complete!"
    echo ""
    echo ""
fi
exit
