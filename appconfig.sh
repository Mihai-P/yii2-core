#!/bin/sh

# Ref: https://github.com/delatbabel/yii2-core#usage
cp -a vendor/tez/yii2-cms-module/deploy/backend+config+main.php backend/config/main.php
cp -a vendor/tez/yii2-cms-module/deploy/common+config+bootstrap.php common/config/bootstrap.php
cp -a vendor/tez/yii2-cms-module/deploy/backend+assets+AppAsset.php backend/assets/AppAsset.php
cp -a vendor/tez/yii2-cms-module/.htaccess backend/web/
cp -a vendor/tez/yii2-cms-module/.htaccess frontend/web/
