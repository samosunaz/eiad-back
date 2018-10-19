#/bin/bash

if test "$#" -ne 1; then
    echo "Illegal number of parameters"
    exit
fi

VERSION=$1
DATE=$(date '+%Y-%m-%d')
IMG_NAME=us.gcr.io/eiad-219804/webserver 


echo "Building image v$VERSION..."
docker build -t $IMG_NAME:$VERSION .

echo "Pushing image to Google Cloud..."
gcloud docker -- push $IMG_NAME:$VERSION
gcloud container images add-tag $IMG_NAME:$VERSION $IMG_NAME:$DATE -q
gcloud container images untag $IMG_NAME:latest -q
gcloud container images add-tag $IMG_NAME:$VERSION $IMG_NAME:latest -q
