import json
import typer
from rich import print as r_print
from typing import List
from typing_extensions import Annotated
from enum import Enum
import sys
import os
import time

from src.helpers import load_config, remove_items
from src.utils import generate_graphs, generate_table
from src.constants import ColorSchemes, ProcessMode, GRAPHS_DIR, SPECIFIC_GRAPHS_DIR, CLEAR_GRAPHS_HELP_VISUALISE, SERVICES_HELP_VISUALISE, COLOR_SCHEMES_HELP_VISUALISE , OUTPUTS_DIR, SPECIFIC_OUTPUT_DIR

sys.dont_write_bytecode = True

# load and process config values
config = load_config()
WHOLE_TEST_REPEATS = config["wholeTestRepeats"]

services_loaded = config["services"]
SERVICES = [service["name"] for service in services_loaded]
services_list = [(service["name"], service["port"]) for service in services_loaded]
services_val_dict = dict((service["name"], service["port"]) for service in services_loaded)
services_name_dict = dict((service["name"], service["name"]) for service in services_loaded)
Services = Enum("Services", services_name_dict)

parameters_loaded = config["parameters"]
PARAMETERS = [(parameter["concurrency"], parameter["count"]) for parameter in parameters_loaded]

CONCURRENCIES = {item["concurrency"]: 0 for item in parameters_loaded}
LATENCIES = {item["concurrency"]: 0 for item in parameters_loaded}


def main(
    service: Annotated[List[Services], typer.Option(case_sensitive=False, help=SERVICES_HELP_VISUALISE)] = [],
    color_scheme: Annotated[ColorSchemes, typer.Option(case_sensitive=False, help=COLOR_SCHEMES_HELP_VISUALISE)] = ColorSchemes.WARM,
    clear_graphs: Annotated[bool, typer.Argument(help=CLEAR_GRAPHS_HELP_VISUALISE)] = False
):
    """
    Analyze measured benchmark results, generate images of graphs and visualise data to a table in CLI. 
    """

    if len(service) == 0:
        r_print("\n[bold green]Generating graphs for all possible services[/bold green]\n")
        first_output_folder = f"{OUTPUTS_DIR}/{SPECIFIC_OUTPUT_DIR.format(1)}"
        services = set()
        for filename in os.scandir(first_output_folder):
            if filename.is_file():
                resulted_service_array = filename.name.split("-")
                if len(resulted_service_array) > 0:
                    services.add(resulted_service_array[0])
        services_to_run = list(services)
    else:
        services_formatted = ", ".join(item.value for item in service)
        r_print(f"\n[bold green]Generating graphs for services: [/bold green] {services_formatted}\n")
        services_to_run = [item.value for item in service]
    
    if (clear_graphs):
        r_print(f"\n[bold green]Removing all old generated graphs: [/bold green]\n")

    table = []
    rps_data = {}
    latency_data = {}

    for benchmark_count in range(WHOLE_TEST_REPEATS):
        current_folder = f"{OUTPUTS_DIR}/{SPECIFIC_OUTPUT_DIR.format(benchmark_count+1)}"
        
        # if port in data, then: for service, _ in services_to_run:
        for service in services_to_run:
            if service not in rps_data:
                rps_data[service] = CONCURRENCIES.copy()
            if service not in latency_data:
                latency_data[service] = LATENCIES.copy()

            for current_concurrency, current_requests in PARAMETERS:
                current_filename = f"{current_folder}/{service}-{current_concurrency}-{current_requests}.json"
                with open(current_filename, "r") as file:
                    data = json.load(file)

                rps_data[service][current_concurrency] += data['result']['rps']['mean']
                #latency_data[service][current_concurrency] += data['result']['latency']['mean']

    # if there's more than one repetition, calculate average
    if (WHOLE_TEST_REPEATS > 1):
        for service, values in rps_data.items():
            rps_data[service] = dict((k, v/WHOLE_TEST_REPEATS) for k, v in values.items())

    # transform final data to table
    for service, values in rps_data.items():
        for current_concurrency, current_requests in PARAMETERS:
            table.append([service, current_concurrency, current_requests, values[current_concurrency]])

    # print generated table to console
    print("\nCelkový výsledek benchmarku", end="")
    print(f" (průměr z {WHOLE_TEST_REPEATS} měření):" if WHOLE_TEST_REPEATS > 1 else ":")
    print(generate_table(table))
    print ("* RPS = Requesty za vteřinu\n")

    # clear old generated graphs if parameter is true
    if (clear_graphs):
        remove_items(GRAPHS_DIR, mode=ProcessMode.DIRECTORIES, extensions=[".png"])

    timestamp = int(time.time())
    for current_concurrency, current_requests in PARAMETERS:
        COLOR_CODES = dict((service["name"], service[color_scheme]) for service in services_loaded)

        try:
            current_file_output = f"{GRAPHS_DIR}/{SPECIFIC_GRAPHS_DIR.format(timestamp)}/RPS_{current_concurrency}.png"
            generate_graphs(current_file_output, current_concurrency, current_requests, COLOR_CODES, rps_data)
        except Exception as e:
            r_print(f"\n\n[bold red] Exception occured in process: [/bold red] {e}\n\n")

if __name__ == "__main__":
    typer.run(main)