#!/bin/bash

# Required libs
# libxml - https://man.archlinux.org/man/libxml.3.en

# make a clean state
rm -rf .tmp
rm -rf src/views/icons/{solid,outline}
mkdir -p src/views/icons/{solid,outline}

# prepare icons
git clone git@github.com:tailwindlabs/heroicons.git .tmp

for FILE in .tmp/src/{outline,solid}/*.svg; do
    echo "$(xmllint --noblanks $FILE)" >| "$FILE"
    echo "$(tail -n +2 $FILE)" >| "$FILE"
    NEW_FILE="${FILE%.svg}.blade.php"
    mv $FILE $NEW_FILE
    echo $NEW_FILE
done

for FILE in .tmp/src/outline/*.php; do
    sed -i 's/ stroke="[^"]*"//g' $FILE
    sed -i 's/<svg/<svg {{ $attributes }} stroke="currentColor"/g' $FILE
done

for FILE in .tmp/src/solid/*.php; do
    sed -i 's/ fill="[^"]*"//g' $FILE
    sed -i 's/<svg/<svg {{ $attributes }} fill="currentColor"/g' $FILE
done

mv .tmp/src/{outline,solid} src/views/icons
rm -rf .tmp
