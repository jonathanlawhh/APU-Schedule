import csv
from operator import itemgetter

input_file = 'a.csv'
output_file = 'data.csv'
try :
	source = open(input_file, 'r')
except :
	print("File not found")

target = open(output_file, 'w', newline='')

sorts = []
sorts.append((5, False))
sorts.append((3, False))

# Read in the data creating a label list and list of one tuple per row
reader = csv.reader(source)
row_count = 0
data=[]
for row in reader:
	row_count += 1
	data.append(tuple(row))

for sort_step in sorts:
	data = sorted(data, key=itemgetter(sort_step[0]))

# Now write all of this out to the new file
writer = csv.writer(target)
for sorted_row in data:
	writer.writerow((sorted_row[1],sorted_row[2],sorted_row[3],sorted_row[4],sorted_row[5],sorted_row[6],sorted_row[7]))

source.closed
target.closed
print ('Sorted CSV')
