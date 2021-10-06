PHP_CS_FIXER := tools/php-cs-fixer/vendor/bin/php-cs-fixer

all : vendor
.PHONY : all

test : vendor
	@rm -rf coverage
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html=coverage --coverage-text --coverage-filter=src test
.PHONY : test

watch :
	git ls-files src test | entr -c -r $(MAKE) -s test
.PHONY : watch

format : $(PHP_CS_FIXER)
	$(PHP_CS_FIXER) fix
.PHONY : format

vendor : composer.lock
	composer install

$(PHP_CS_FIXER) : tools/php-cs-fixer/composer.lock
	composer --working-dir=$(dir $<) install
