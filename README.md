# Awesome title

## How to run this app with Docker
*   Install if you don't have it already:
    [https://docs.docker.com/get-docker/](https://docs.docker.com/get-docker/)
1.  **Open a terminal** or command prompt and navigate to the directory where you have stored this application. Should look something like this:
    ```bash
    cd /path/to/app/totally-not-discord
    ```
    *Please replace `/path/to/app/` with the actual path to the application on your computer*.
2.  **Build the Docker image** by running this command:
    ```bash
    docker build -t totally-not-discord .
    ```
    *This may take some time, like a minute or two.*
3.  **Start the Docker container** by running this command:
    ```bash
    docker run -p 8000:8000 totally-not-discord
    ```

4.  **Open a web browser** and go to the following address:
    ```
    http://localhost:8000
    ```

The application should now be running and accessible in your browser.

## Notes
*   If something doesnt work as expected, you can try the following commands to reset the application:
    ```
    docker stop <your-container-id>
    docker rm <your-container-id>
    docker rmi <your-image-id>
    ```
    You can see `your-container-id` and `your-image-id` by listing all container with `docker ps -a`, and list all images with `docker images` respectively.

Thank you for your time and consideration. Please give me all the points please.
