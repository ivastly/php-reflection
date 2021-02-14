.PHONY: test
test:
	docker-compose run php php vendor/bin/phpunit --colors=always --bootstrap=test/bootstrap.php test
