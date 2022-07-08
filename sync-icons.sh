#!/bin/bash

# Required the lib libxml
# https://man.archlinux.org/man/libxml.3.en

# make a clean state
rm -rf ./src/views/components/outline
rm -rf ./src/views/components/solid
rm -rf .tmp .tmp-svg

# prepare icons
git clone git@github.com:tailwindlabs/heroicons.git .tmp
mkdir .tmp-svg
mv .tmp/src/outline .tmp-svg
mv .tmp/src/solid .tmp-svg

export XMLLINT_INDENT="    "

for FILE in .tmp-svg/outline/*.svg .tmp-svg/solid/*.svg; do
    echo "$(xmllint --format $FILE)" >| "$FILE";
    echo "$(tail -n +2 $FILE)" >| "$FILE";
    mv -- "$FILE" "${FILE%.svg}.blade.php";
done

for FILE in .tmp-svg/outline/*.php; do
    sed -i 's/ stroke="[^"]*"//g' $FILE
    sed -i 's/<svg/<svg {{ $attributes }} stroke="currentColor"/g' $FILE;
done

for FILE in .tmp-svg/solid/*.php; do
    sed -i 's/ fill="[^"]*"//g' $FILE
    sed -i 's/<svg/<svg {{ $attributes }} fill="currentColor"/g' $FILE;
done

mv .tmp-svg/outline src/views/components
mv .tmp-svg/solid src/views/components
rm -rf .tmp .tmp-svg
