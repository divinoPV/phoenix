# Phoenix
The project that rose from the ashes, Phoenix was initially an online project management platform for the project managers of a French bank created by Gregoire Rondet.

For my license project I had the task to make it rise from its ashes with the latest stacks (Symfony 6 and PHP 8.1).

## Install

Execute commands in your favorite terminal :

1. Clone project `git clone git@github.com:divinoPV/phoenix.git`
2. Go to Linux hosts file `sudo nano \etc\hosts`, enter your password
3. Add line `127.0.0.1 phoenix.co` and save file
4. Go in project `cd %PROJECT_PATH%\phoenix`
5. Start project `make start`
6. Go to [http://phoenix.co](http://phoenix.co) in your favorite web browser

## Fixtures
### Users and database
| Role                 | Email                                 | Password |
|:---------------------|:--------------------------------------|:---------|
| admin                | admin{1;4}@phoenix.co                 | xxx      |
| responsible_project  | responsible_project{1;7}@phoenix.co   | xxx      |
| responsible_customer | responsible_customer{1;15}@phoenix.co | xxx      |
| member_project       | member_project{1;24}@phoenix.co       | xxx      |
| member_customer      | member_customer{1;35}@phoenix.co      | xxx      |
| database             | root                                  | root     |

## Support

You can email [divino][email] if you have any questions.

## Authors

Entirely made by [divino][github].

[email]: (mailto:hmonteiro.dev@gmail.com?subject=[GitHub]%20Source%20Han%20Sans)
[github]: (https://github.com/divinoPV/)
