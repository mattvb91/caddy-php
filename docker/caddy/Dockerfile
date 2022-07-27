FROM caddy:2.5.1-builder-alpine

RUN xcaddy build --with github.com/darkweak/souin/plugins/caddy \
    --with github.com/darkweak/souin@v1.6.17


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