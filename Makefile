# Makefile
# --------
# Builds assets and documentation for ARCS.
#          _____                    _____                    _____                    _____
#         /\    \                  /\    \                  /\    \                  /\    \
#        /::\    \                /::\    \                /::\    \                /::\    \
#       /::::\    \              /::::\    \              /::::\    \              /::::\    \
#      /::::::\    \            /::::::\    \            /::::::\    \            /::::::\    \
#     /:::/\:::\    \          /:::/\:::\    \          /:::/\:::\    \          /:::/\:::\    \
#    /:::/__\:::\    \        /:::/__\:::\    \        /:::/  \:::\    \        /:::/__\:::\    \
#   /::::\   \:::\    \      /::::\   \:::\    \      /:::/    \:::\    \       \:::\   \:::\    \
#  /::::::\   \:::\    \    /::::::\   \:::\    \    /:::/    / \:::\    \    ___\:::\   \:::\    \
# /:::/\:::\   \:::\    \  /:::/\:::\   \:::\____\  /:::/    /   \:::\    \  /\   \:::\   \:::\    \
#/:::/  \:::\   \:::\____\/:::/  \:::\   \:::|    |/:::/____/     \:::\____\/::\   \:::\   \:::\____\
#\::/    \:::\  /:::/    /\::/   |::::\  /:::|____|\:::\    \      \::/    /\:::\   \:::\   \::/    /
# \/____/ \:::\/:::/    /  \/____|:::::\/:::/    /  \:::\    \      \/____/  \:::\   \:::\   \/____/
#          \::::::/    /         |:::::::::/    /    \:::\    \               \:::\   \:::\    \
#           \::::/    /          |::|\::::/    /      \:::\    \               \:::\   \:::\____\
#           /:::/    /           |::| \::/____/        \:::\    \               \:::\  /:::/    /
#          /:::/    /            |::|  ~|               \:::\    \               \:::\/:::/    /
#         /:::/    /             |::|   |                \:::\    \               \::::::/    /
#        /:::/    /              \::|   |                 \:::\____\               \::::/    /
#        \::/    /                \:|   |                  \::/    /                \::/    /
#         \/____/                  \|___|                   \/____/                  \/____/
#
# @package    ARCS
# @link       http://svn.matrix.msu.edu/svn/arcs/
# @copyright  Copyright 2012, Michigan State University Board of Trustees
# @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
#
# @author SOFTWARE LEAD: SEILA GONZALEZ
#					SOFTWARE DEVS: AUSTIN RIX, CHARLIE DENEUA, JOSH CHRIST, MATT SCHLEUSENER
#												 ARNOLD MUTAYOBA, JACOB BUCKLEY
# @design AUSTIN TRUCHAN, ALEXIS REININGER
# @documentation https://wiki.matrix.msu.edu/index.php/Arcs_Documentation

#
# To use it, you'll need NodeJS and the following NPM packages:
#   - uglify-js
#   - clean-css
#   - less
#
# To build the docs, we're using markdown_py, from the Python
# Markdown module. You can substitute it with another Markdown
# converter that supports tables.
#

# Asset dirs
CSS=app/webroot/css
ASSETS=app/webroot/assets

# Need to outsource parsing the INI file
SCRIPTS=$(shell bin/get-assets --js)
STYLESHEETS=$(shell bin/get-assets --css)

DOCS=$(wildcard docs/*.md)

# ARCS version and license header
VERSION=$(shell cat VERSION)
BUILT_ON=$(shell date)
BUILT_WITH=$(shell git log -1 --format="%h")
HEADER="/**\n\
  * ARCS\n\
  * $(VERSION)\n\
  * Generated on $(BUILT_ON) with $(BUILT_WITH)\n\
  *\n\
  * Copyright 2012-2013, Michigan State University Board of Trustees\n\
  */"

.PHONY: docs

default:all

install:
	php ini/configure.ini.php
bootstrap:
	php ini/bootstrap.ini.php

# Compile less in (and included in) css/app.less to css/app.css
less:
	cd $(CSS); lessc app.less > app.css

# Concatenate and minify css.
css: less
	echo $(HEADER) > $(ASSETS)/arcs.css
	$(foreach style, $(STYLESHEETS), cleancss $(CSS)/$(style) >> $(ASSETS)/arcs.css;)

# Convert user documentation from Markdown and put it in the View directory.
docs:
	$(foreach doc, $(DOCS), python -m markdown -x tables -x headerid $(doc) > \
		app/View/Help/$(notdir $(basename $(doc))).ctp;)

# Install the packages we use.
install-tools:
	npm install -g uglify-js
	npm install -g clean-css
	npm install -g less

# use to clear all tmp files.  This can be beneficial if the cache is preventing things (cached old html not updating to new html, database, etc.) from updating.
clear_tmp:
	rm -f app/tmp/cache/models/*
	rm -f app/tmp/cache/persistent/*
	rm -f app/tmp/cache/views/*
	rm -f app/tmp/sessions/*
	rm -f app/tmp/tests/*

# Make everything.
all: css docs
