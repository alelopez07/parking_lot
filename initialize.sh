#--------------------------------------------------------------------------
# initialize.sh script file
#--------------------------------------------------------------------------
#
# After executing the genesis script or you are in a genesis, this script will 
# help you initialize the containers for parking lot project.

docker-compose build --no-cache
docker-compose up -d