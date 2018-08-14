help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  tag  to modify the version"

tag:
	$(if $(TAG),,$(error TAG is not defined. Pass via "make tag TAG=2.5.1"))
	@echo Tagging $(TAG)
	sed -i "s/const VERSION = '.*';/const VERSION = '$(TAG)';/" MangoPay/Libraries/RestTool.php
	php -l MangoPay/Libraries/RestTool.php
