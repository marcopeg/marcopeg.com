#
# Force to recreate Wordpress image
# use this for new production releases
#

if [ "$PRINT_FEEDBACK" == "yes" ]; then
    echo ""
    echo "You are about to upgrade the project:"
    echo "    - shut down the app"
    echo "    - pull current branch"
    echo "    - start over"
    echo ""
    echo "Please take the time to answer thos questions:"
    echo "    - do you know what are you doing?"
    echo "    - did you run a backup?"
    echo "    - is this the correct git branch?"
    echo "    - is the repository in a clean state?"
    echo ""
    enterToContinue
fi

git pull
humble stop wordpress
humble rm -f wordpress
humble up -d --build wordpress
