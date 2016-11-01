#
# Force to recreate Wordpress image
# use this for new production releases
#

git pull
humble stop wordpress
humble rm -f wordpress
humble up -d --build wordpress
