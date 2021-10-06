all : vendor

test : vendor
	vendor/bin/phpunit test
.PHONY : test

vendor : composer.lock
	composer install
