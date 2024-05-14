from enum import Enum
import sys

sys.dont_write_bytecode = True

class ProcessMode(Enum):
    DIRECTORIES = 1
    FILES = 2
    
class ColorSchemes(str, Enum):
    WARM = "color_warm"
    COLD = "color_cold"

COLOR_SCHEMES_HELP_VISUALISE = "Name of color scheme to be used for bar graph generation."
SERVICES_HELP_VISUALISE = "List of service names to be included in the graphs. If no services are specified, graphs are generated from  all possible services in the output folder."
CLEAR_GRAPHS_HELP_VISUALISE = "If true, all the old generated graphs in graphs/ folder will be removed."
SERVICES_HELP_BENCHMARK = "List of service names to be included in the benchmark. If no services are specified, all services will be benchmarked."

COMMAND = "bombardier -c {} -n {} -l -p result -o json http://{}:{}/"
TEXTBOX_CONTENT = "Počet requestů: {}\nNaráz requestů: {}"
#GRAPH_TEXTBOX_STYLE = dict(boxstyle='round', facecolor='wheat', alpha=0.3)

CONFIG_PATH = "config.json"
GRAPHS_DIR = "graphs"
SPECIFIC_GRAPHS_DIR = "graphs_{}"
OUTPUTS_DIR = "outputs"
SPECIFIC_OUTPUT_DIR = "output_{}"
