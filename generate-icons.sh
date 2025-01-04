#!/bin/bash

# Required libs
# libxml - https://man.archlinux.org/man/libxml.3.en

# make a clean state
rm -rf .tmp
rm -rf src/views/components
mkdir -p src/views/components/{solid,outline}
mkdir -p src/views/components/{mini,micro}/solid

# prepare icons
git clone git@github.com:tailwindlabs/heroicons.git .tmp

for FILE in .tmp/src/{16,20,24}/{outline,solid}/*.svg; do
    echo "$(xmllint --noblanks $FILE)" >| "$FILE"
    echo "$(tail -n +2 $FILE)" >| "$FILE"
    NEW_FILE="${FILE%.svg}.blade.php"
    mv $FILE $NEW_FILE
    echo $NEW_FILE
done

for FILE in .tmp/src/24/outline/*.php; do
    sed -i '' 's/ stroke="[^"]*"//g' $FILE
    sed -i '' 's/<svg/<svg {{ $attributes }} stroke="currentColor"/g' $FILE
done

for FILE in .tmp/src/{16,20,24}/solid/*.php; do
    sed -i '' 's/ fill="[^"]*"//g' $FILE
    sed -i '' 's/<svg/<svg {{ $attributes }} fill="currentColor"/g' $FILE
done

mv .tmp/LICENSE src/views/components/LICENSE
mv .tmp/src/16/solid src/views/components/micro
mv .tmp/src/20/solid src/views/components/mini
mv .tmp/src/24/{outline,solid} src/views/components
rm -rf .tmp
