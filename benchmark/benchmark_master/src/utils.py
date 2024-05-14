import subprocess
from src.constants import TEXTBOX_CONTENT
import matplotlib.pyplot as plt
import sys
from tabulate import tabulate
import os

sys.dont_write_bytecode = True

def run_batch(file_output: str, command_to_run: str):
    output = open(file_output, "w")

    # generated command is executed and result is saved to JSON file
    process = subprocess.Popen(command_to_run, shell=True, stdout=output, stderr=subprocess.PIPE)
    _, stderr = process.communicate()

    if stderr:
        raise Exception(f"Error in process: {stderr}")
 
def generate_graphs(file_output: str, current_concurrency: int, current_requests: int, color_codes, data):
    os.makedirs(os.path.dirname(file_output), exist_ok=True)

    #current_textbox = TEXTBOX_CONTENT.format(current_requests, current_concurrency) 

    x_axis_unsorted = []
    y_axis_unsorted  = []
    for i, (service, values) in enumerate(data.items()):
        x_axis_unsorted.append(service)
        y_axis_unsorted.append(values[current_concurrency])
        
    y_axis, x_axis = zip(*sorted(zip(y_axis_unsorted, x_axis_unsorted), reverse=True))

    fig, ax = plt.subplots()
    fig.set_figwidth(10)

    colors_sorted = [color_codes[current_service] for current_service in x_axis]

    ax.set_title(f"Průměrně requestů za vteřinu (RPS); concurrency {current_concurrency}")
    ax.set_xlabel("RPS", alpha=0.8)
    ax.set_ylabel("Služba", alpha=0.8)
    hbars = ax.barh(x_axis, y_axis, color=colors_sorted, edgecolor="Black", linewidth=0.4)
    ax.invert_yaxis()
    ax.grid(axis='x', which='both', alpha=0.4)
    ax.bar_label(hbars, label_type="edge", fmt="%i", padding=7, fontsize=11, alpha=0.9)
    ax.margins(x=0.12)

    #plt.text(0.05, 0.95, current_textbox, fontsize=14, verticalalignment='top', bbox=GRAPH_TEXTBOX_STYLE)

    plt.savefig(file_output)
    plt.close()

def generate_table(table):
    return tabulate(table, 
                    headers=["Služba", "Requestů naráz", "Requestů celkem", "Průměrné RPS*"], 
                    tablefmt="heavy_grid", 
                    numalign="right")