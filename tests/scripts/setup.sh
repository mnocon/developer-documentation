#!/bin/bash

TUTORIAL_REPOSITORY=https://github.com/ezsystems/ezplatform-ee-beginner-tutorial
TUTORIAL_DATA_DIRECTORY=tutorial_data
IMAGES_SOURCE=vendor/ezsystems/developer-documentation/docs/tutorials/enterprise_beginner/img/photos.zip
IMAGES_DESTINATION=./images

# clone tutorial data
git clone $TUTORIAL_REPOSITORY --depth=1 $TUTORIAL_DATA_DIRECTORY

# add suite to Behat
echo '    - vendor/ezsystems/developer-documentation/tests/behat_suites.yml' >> behat.yml.dist

#copy images
mkdir $IMAGES_DESTINATION
unzip $IMAGES_SOURCE -d $IMAGES_DESTINATION
