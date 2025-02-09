# Run console
alias docker-run-console='docker exec -it php-fpm bin/console'

# Run composer
alias docker-run-composer='docker exec -it php-fpm composer'

# Run php stan
alias docker-run-stan='docker exec -it php-fpm tools/phpstan/vendor/bin/phpstan analyse -l 8 src tests'

# Run phpcs
alias docker-run-cs='docker exec -it php-fpm tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src'