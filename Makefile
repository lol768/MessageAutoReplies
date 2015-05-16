SHELL := /usr/bin/zsh
all: addon-MessageAutoReplies.xml
	rm upload/ -rf; \
	mkdir -p upload/library/MessageAutoReplies/; \
	rsync -av --exclude='upload' --exclude='vendor' --exclude='target' --exclude='.idea' --exclude='.git' . upload/library/MessageAutoReplies/; \
	mkdir -p target; \
	rm target/* -rf; \
	zip -r target/MessageAutoReplies.zip upload addon-MessageAutoReplies.xml LICENSE;
tests:
	vendor/bin/phpunit
