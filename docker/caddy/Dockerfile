FROM caddy:2.6.0-builder-alpine

RUN xcaddy build --with github.com/darkweak/souin/plugins/caddy@a2e88383a2bced983914cc12bde413ad8887b56d \
    --with github.com/darkweak/souin@a2e88383a2bced983914cc12bde413ad8887b56d


# See https://caddyserver.com/docs/conventions#file-locations for details
ENV XDG_CONFIG_HOME /config
ENV XDG_DATA_HOME /data

VOLUME /config
VOLUME /data

# Init the autosave.json file for each time the server starts
COPY autosave.json /config/caddy/autosave.json

EXPOSE 80
EXPOSE 443
EXPOSE 2019

WORKDIR /srv