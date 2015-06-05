MarshalTripleiCoreAMI [![Build Status](https://travis-ci.org/triple-i/MarshalTripleiCoreAMI.svg?branch=master)](https://travis-ci.org/triple-i/MarshalTripleiCoreAMI)
===

TripleI/Core AMI イメージを三世代分維持するツールです。

## Description

このツールを使うと、TripleI/Core AMI を最新三世代分だけ残し、残りの AMI を破棄します。  
煩雑に増えていく AMI イメージを簡単に整理することが可能です。

## Requirement

PHP 5.4+

## Usage

コマンドひとつで整理出来ます。  
Jenkins など CI サービスと組み合わせると良いでしょう。

```
$ bin/marshal
```

## Install

```
$ git clone https://github.com/triple-i/MarshalTripleiCoreAMI.git
$ cd MarshalTripleiCoreAMI
$ composer install
```

## License

[MIT](https://github.com/triple-i/MarshalTripleiCoreAMI/blob/master/LICENSE)

## Author

[triple-i](https://github.com/triple-i)