import typer
from rich import print as r_print
from typing import List
from typing_extensions import Annotated
from enum import Enum
import sys
import os

from src.helpers import load_config, get_command, remove_items
from src.utils import run_batch
from src.constants import ProcessMode, OUTPUTS_DIR, SPECIFIC_OUTPUT_DIR, SERVICES_HELP_BENCHMARK

sys.dont_write_bytecode = True

# load and process config values
config = load_config()

WHOLE_TEST_REPEATS = config["wholeTestRepeats"]
PARAMETERS_COUNT = len(config["parameters"])

parameters_loaded = config["parameters"]
PARAMETERS = [(parameter["concurrency"], parameter["count"]) for parameter in parameters_loaded]

services_loaded = config["services"]
services_list = [(service["name"], service["port"]) for service in services_loaded]
services_val_dict = dict((service["name"], service["port"]) for service in services_loaded)
services_name_dict = dict((service["name"], service["name"]) for service in services_loaded)
Services = Enum("Services", services_name_dict)

# function to run all batches in benchmark
def run_full_benchmark(services_to_run):
    batch_count = 1
    remove_items(OUTPUTS_DIR, mode=ProcessMode.DIRECTORIES)

    for benchmark_count in range(WHOLE_TEST_REPEATS):
        current_folder = f"{OUTPUTS_DIR}/{SPECIFIC_OUTPUT_DIR.format(benchmark_count+1)}"

        # create directory if not present
        if not os.path.isdir(current_folder):
            os.mkdir(current_folder)

        for service, port in services_to_run:
            for current_concurrency, current_requests in PARAMETERS:
                current_filename = f"{current_folder}/{service}-{current_concurrency}-{current_requests}.json"
                current_command = get_command(service, port, current_concurrency, current_requests)

                try:
                    run_batch(current_filename, current_command)
                except Exception as e:
                    r_print(f"\n\n[bold red] Exception occured in process: [/bold red] {e.message}\n\n")

                yield batch_count
                batch_count += 1
                
def main(
    service: Annotated[List[Services], typer.Option(case_sensitive=False, help=SERVICES_HELP_BENCHMARK)] = [],
):
    """
    Run benchmark for entered services.
    """
    if len(service) == 0:
        r_print("\n[bold green]Starting benchmark for all services[/bold green]\n\n")
        services_to_run = services_list.copy()
    else:
        services_formatted = ", ".join(item.value for item in service)
        r_print(f"\n[bold green]Starting benchmark for services: [/bold green] {services_formatted}\n\n")
        # transform data - add port to each service specified by user
        services_to_run = [(item.value, services_val_dict[item.value]) for item in service]

    TOTAL_BATCH_COUNT = WHOLE_TEST_REPEATS * len(services_to_run) * PARAMETERS_COUNT
    with typer.progressbar(run_full_benchmark(services_to_run), 
                           length=TOTAL_BATCH_COUNT, 
                           label="Running benchmark") as progress:
        processed = 0
        for _ in progress:
            processed += 1

        r_print(f"\n[blue]Benchmark done, processed {processed} / {TOTAL_BATCH_COUNT} batches.[/blue]\n")

if __name__ == "__main__":
    typer.run(main)