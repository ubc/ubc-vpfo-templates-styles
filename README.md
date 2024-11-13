# Using CodeSniffer to validate for WordPress Extra coding standards

1) Ensure that you have Composer installed globally and up to date

2) In the ubc-vpfo-spaces-pages project root directory, run 
```composer install``` 
to install/update packages

3) In your local ~/.zshrc file, add the following code block (if you have not already done so):

```
# CodeSniffer project alias
function set_phpcs_alias() {
    if [ -f "./vendor/bin/phpcs" ]; then
        alias phpcsproject='./vendor/bin/phpcs . --standard=phpcs.xml --report=full --report-file=codescan.txt'
    else
        unalias phpcsproject 2>/dev/null
    fi
}

# Run this function before each prompt
PROMPT_COMMAND="set_phpcs_alias; $PROMPT_COMMAND"

# Also run it for the initial directory
set_phpcs_alias
```

4) Save your ~/.zshrc file
5) run the command: ```source ~/.zshrc```
6) Quit any open terminal applications and relaunch them
7) From the ubc-vpfo-templates-styles project root directory, run the command: 
```phpcsproject```
to scan your code according to WordPress Extra coding standards. The results will output to a file in the project root folder called ```codescan.txt```