FROM golang:latest

WORKDIR /app

COPY /src/main.go .

RUN go mod init main.go
RUN go get -u github.com/valyala/fasthttp
RUN go build -o main.go

CMD ["./main.go"]