.PHONY: test test-coverage

test:
	docker-compose run php php vendor/bin/phpunit --colors=always --bootstrap=test/bootstrap.php test

test-with-coverage:
	docker-compose run php php -dxdebug.mode=coverage vendor/bin/phpunit --colors=always --bootstrap=test/bootstrap.php \
	 --coverage-html=test/output/coverage --coverage-text --coverage-filter=src test
