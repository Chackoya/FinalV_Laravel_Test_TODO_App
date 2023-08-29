#!/bin/bash
# Start the containers in detached mode
echo "Starting the containers, the build might take a while (first run it takes around 500 - 600s due to npm and node packages, then it's faster)... \n"
docker compose up --build -d



# Follow the logs for the 'app' service
#Remove this line if you don't want to follow the logs of the app. 
# IMPORTANT NOTE:
# The db takes some time to start initially, so only launch the app in localhost (http://localhost:8000/) after the completion of the database and its commands (migrations etc).
# Check commands in the entrypoint.sh file for more details.

docker compose logs -f app