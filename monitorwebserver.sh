#!/bin/bash

PHP_BIN="/usr/bin/php" # Path to PHP binary
DOCUMENT_ROOT="/var/www/" # Document root of the server
HOST="0.0.0.0" # Host to bind the server
PORT="8000" # Port to bind the server
PID_FILE="/tmp/php_server.pid" # PID file location
LOG_FILE="/tmp/php_server.log" # Log file location

# Function to start the server
start() {
    if [ -f "$PID_FILE" ] && kill -0 $(cat "$PID_FILE") 2>/dev/null; then
        echo "PHP server is already running."
    else
        echo "Starting PHP server..."
        nohup "$PHP_BIN" -S "$HOST":"$PORT" -t "$DOCUMENT_ROOT" >> "$LOG_FILE" 2>&1 &
        echo $! > "$PID_FILE"
        echo "PHP server started."
    fi
}

# Function to stop the server
stop() {
    if [ -f "$PID_FILE" ] && kill -0 $(cat "$PID_FILE") 2>/dev/null; then
        echo "Stopping PHP server..."
        kill $(cat "$PID_FILE")
        rm -f "$PID_FILE"
        echo "PHP server stopped."
    else
        echo "PHP server is not running."
    fi
}

# Function to check the server status
status() {
    if [ -f "$PID_FILE" ] && kill -0 $(cat "$PID_FILE") 2>/dev/null; then
        echo "PHP server is running."
    else
        echo "PHP server is not running."
    fi
}

# Main logic
case "$1" in
    start)
        start
        ;;
    stop)
        stop
        ;;
    status)
        status
        ;;
    restart)
        stop
        start
        ;;
    *)
        echo "Usage: $0 {start|stop|status|restart}"
        exit 1
        ;;
esac

exit 0