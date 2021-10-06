all : vendor

test : vendor
	@rm -rf coverage
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html=coverage --coverage-text --coverage-filter=src test
.PHONY : test

watch :
	git ls-files src test | entr -c -r $(MAKE) -s test

vendor : composer.lock
	composer install
