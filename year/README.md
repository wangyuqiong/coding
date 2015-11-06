# Find Year With Most People Alive

## Design

- Assume data is in the format of birth_year,end_year
- The function findYear first reads in the data
- Data is iterated once
- For every row, each year within [birth_year, end_year] is added to a bucket
- If the bucket already exists, its count is incremented
- During the process, a global variable remembers the maximum count seen so far
- After all the rows are read, we know the maximum number of people alive is the maximum count
- We go through the buckets to retrieve all the years with the maximum count
- Function returns a tuple [year, number], where year is (a list of) the year(s) with most number of people alive, and number is the maximum number of people alive

## Usage

- To run the sample tests:
Python find.py

- To run the function on a given data file (format: birth_year,end_year):
year, number = findYear("test_file.txt")
Where the return value year is (a list of) the year(s) with most number of people alive
And number is the maximum number of people alive

## Sample output 

output.png