package main

import (
	"encoding/json"
	"fmt"
	"runtime"
	"github.com/valyala/fasthttp"
	"time"
)

type JsonResponse struct {
	version   string `json:"version"`
	name      string `json:"name"`
	timestamp int64  `json:"timestamp"`
}

func main() {
	requestHandler := func(ctx *fasthttp.RequestCtx) {
		switch string(ctx.Path()) {
			case "/":
				response := JsonResponse{
					version:   runtime.Version(),
					name:      "Golang (fasthttp)",
					timestamp: time.Now().Unix(),
				}

				ctx.SetContentType("application/json")
				if err := json.NewEncoder(ctx).Encode(response); err != nil {
					fmt.Fprintf(ctx, "Error encoding JSON: %v", err)
					return
				}
			default:
				ctx.Error("Unsupported path", fasthttp.StatusNotFound)
		}
	}

	fmt.Println("Server běží na portu :8006")
	fasthttp.ListenAndServe(":8006", requestHandler)
}