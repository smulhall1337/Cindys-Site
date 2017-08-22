.PHONY: run

run:
	@docker run --rm -v `pwd`:/srv/http -p 80:80 greyltc/lamp
