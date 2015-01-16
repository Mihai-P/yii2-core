#!/bin/sh

#
# Smart little documentation generator.
# GPL/LGPL
# (c) Del 2015 http://www.babel.com.au/
#

APPNAME='Yii2 CMS Module'
CMDFILE=apigen.cmd.$$
DESTDIR=./documents

#
# Find apigen, either in the path or as a local phar file
#
if [ -f apigen.phar ]; then
    APIGEN="php apigen.phar generate"

else
    APIGEN=`which apigen`
    if [ ! -f "$APIGEN" ]; then
        echo "apigen is not installed in the path or locally, please install it"
        echo "see http://www.apigen.org/"
        exit 1
    fi
    APIGEN="$APIGEN generate"
fi
#
# TODO: Search for phpdoc if apigen is not found.
#

#
# Without any arguments this builds the entire system documentation,
# making the cache file first if required.
#
if [ -z "$1" ]; then
    #
    # Check to see that the cache has been made.
    #
    if [ ! -f dirlist.cache ]; then
        echo "Making dirlist.cache file"
        $0 makecache
    fi

    #
    # Build the apigen command in a file.
    #
    echo "$APIGEN --php --tree --title '$APPNAME API Documentation' --destination $DESTDIR/main \\" > $CMDFILE
    cat dirlist.cache | while read dir; do
        echo "--source $dir \\" >> $CMDFILE
    done
    echo "" >> $CMDFILE

    #
    # Run the apigen command
    #
    mkdir -p $DESTDIR/main
    . ./$CMDFILE
    
    /bin/rm -f ./$CMDFILE

#
# The "makecache" argument causes the script to just make the cache file
#
elif [ "$1" = "makecache" ]; then
    echo "Find application source directories"
    find components controllers models widgets -name \*.php -print | \
        (
            while read file; do
                grep -q 'class' $file && dirname $file
            done
        ) | sort -u | \
        grep -v -E 'config|docs|migrations|test|Test|views|web' > dirlist.app

    echo "Find vendor source directories"
    find vendor -name \*.php -print | \
        (
            while read file; do
                grep -q 'class' $file && dirname $file
            done
        ) | sort -u | \
        grep -v -E 'config|docs|migrations|test|Test|views' > dirlist.vendor
  
    #
    # Filter out any vendor directories for which apigen fails
    #
    echo "Filter source directories"
    mkdir -p $DESTDIR/tmp
    cat dirlist.app dirlist.vendor | while read dir; do
        $APIGEN --quiet --title "Test please ignore" \
            --source $dir \
            --destination $DESTDIR/tmp && (
                echo "Including $dir"
                echo $dir >> dirlist.cache
            ) || (
                echo "Excluding $dir"
            )
    done
    echo "Documentation cache dirlist.cache built OK"
    
    #
    # Clean up
    #
    /bin/rm -rf $DESTDIR/tmp

fi
