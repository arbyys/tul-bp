FROM alpine:3.19

WORKDIR /app

COPY . .
     
RUN apk update && \
    apk add --no-cache python3 py3-pip curl build-base cmake git rsync

RUN wget https://github.com/codesenberg/bombardier/releases/download/v1.2.6/bombardier-linux-amd64 -O bombardier && \
     pwd && \
     mv bombardier /usr/bin/ && \
     chmod +x /usr/bin/bombardier && \
     rm /usr/lib/python3.11/EXTERNALLY-MANAGED && \
     pip install -r requirements.txt

CMD ["/bin/sh"]