#--------------------------------------------------------------------------
# genesis.sh script file
#--------------------------------------------------------------------------
#
# A script to return to genesis the container system.

docker container stop $(docker container ls -aq)
docker container rm $(docker container ls -aq)
docker image prune
docker container prune
docker system prune -a