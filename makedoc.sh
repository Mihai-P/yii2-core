#!/bin/sh

mkdir -p ./reports
mkdir -p ./documents/apigen

if [ -z "$1" ]; then
    apigen \
    --title 'Yii2 CMS Module API documentation' \
    --source ./components \
    --source ./controllers \
    --source ./models \
    --source ./widgets \
    --destination ./documents/apigen \
    --report ./reports/apigen.xml

elif [ "$1" = "yii" ]; then
    apigen \
    --title 'Yii 2 API documentation' \
    --source ./bundles/sitepro/vendors/Zend \
    --exclude '*/bundles/sitepro/vendors/Zend/Console/*' \
    --destination ./documents/apigen \
    --report ./reports/apigen.xml

fi
