# Merged tweets and random jokes list
## Information
Little application for list any of your favourite two twitter users latest tweets in a merged list ordered by date desc with random jokes.
Written in Symfony 4.

## Configuration
### Twitter App key and secret
You can setup in the ```.env``` file for every of your environments separately. Example:
``` 
# Twitter App account
TWITTER_APP_KEY="your_twitter_app_key_hash"
TWITTER_APP_SECRET="your_twitter_app_long_secret_hash"
```
## Usage
A simple way to use is the built in Symfony web server in your localhost. Please read this documentation for usage:
https://symfony.com/doc/current/setup/built_in_web_server.html

Then you can call url-s like this ``` /:twitter_user_1/:twitter_user_2/:method ```

For example: ``` http://127.0.0.1:8000/knplabs/symfony/mod ```

Method parameter could be ```mod``` or ```fib``` (this is the default if parameter not passed):
  * ```mod``` : every 3. element will be a joke in the merged list
  * ```fib``` : in every row number which is fibonacci number insert a joke