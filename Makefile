build:
	docker build -t error-logger-api-base docker/base/.
	docker-compose up -d --build
run:
	docker-compose up -d