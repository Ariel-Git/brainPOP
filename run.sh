#!/bin/bash

# Define variables
SERVER_PATH="./server"
CLIENT_PATH="./client"

# Function to check if composer is installed
check_composer() {
  if ! command -v composer &> /dev/null; then
    echo "Composer is not installed."
    exit 1
  fi
}

# Function to install composer packages
install_composer_packages() {
  cd "$SERVER_PATH"
  composer install
  cd ..
}

install_custom_packages(){
  
}

# Function to check if .env exists
check_env() {
  if [ ! -f "$SERVER_PATH/.env" ]; then
    cp "$SERVER_PATH/.env.example" "$SERVER_PATH/.env"
  fi
}

# Function to update .env with current path
update_env() {
  DB_DATABASE="$(pwd)/server/database/database.sqlite"
  sed -i "s|^DB_DATABASE=.*|DB_DATABASE=$DB_DATABASE|" "$SERVER_PATH/.env"
}

# Function to replace a string in a file (similar to :replace_str)
replace_str() {
  local file="$1"
  local search="$2"
  local replace="$3"
  sed -i "s/$search/$replace/g" "$file"
}

# Function to run php artisan serve
serve() {
  cd "$SERVER_PATH"
  php artisan serve --port 3000 &  # Run in the background
  cd ..
}

# Function to check if npm is installed
check_client_deps() {
  if ! command -v npm &> /dev/null; then
    echo "npm is not installed."
    exit 1
  fi
}

# Function to install client dependencies
install_client_deps() {
  cd "$CLIENT_PATH"
  npm install
  cd ..
}

# Function to serve the client (npm run dev)
serve_client() {
  cd "$CLIENT_PATH"
  npm run dev &  # Run in the background
  cd ..
}

# Main execution
check_composer
install_composer_packages
check_env
update_env
serve
check_client_deps
install_client_deps
serve_client