#--------------------------------------------------------------------------
# initialize.sh script file
#--------------------------------------------------------------------------
#
# After executing the genesis script, this script will help you initialize the containers
# for parking lot project.

docker-compose build --no-cache
docker-compose up -d