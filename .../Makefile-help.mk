ESC   := $(shell printf '\033')
BOLD  := $(ESC)[0;1m
RESET := $(ESC)[0m
TRACE  = @$(if $(2), \
	printf '%s $(BOLD)%s$(RESET)…\n' "$(1)" "$(2)", \
	printf '%s\n' "$(1)")

#
help: # Shows this help.
	@\
	awk ' \
	BEGIN { \
		FS = ":.*#"; \
		max = 0; \
		n = 0; \
	} \
	/^[[:alnum:]_%-]+:.*#/ \
	{ \
		targets[n] = $$1; \
		descs  [n] = $$2; \
		if (length($$1) > max) { \
			max = length($$1); \
		}; \
		n++; \
		next; \
	}; \
	/^#/ \
	{ \
		sub(/^# ?/, """"); \
		sections[n] = $$0; \
		targets [n] = "" ; \
		descs   [n] = "" ; \
		n++; \
	} \
	END { \
		for (i = 0; i < n; i++) { \
			if (targets[i] != "") { \
				printf "$(BOLD)%-*s$(RESET) %s\n", max + 1, targets[i], descs[i]; \
			} else if (sections[i] != "") { \
				printf "%s\n", sections[i]; \
			} else { \
				printf "\n"; \
			}; \
		} \
	} \
	' $(MAKEFILE_LIST)

#
%:
	@:
