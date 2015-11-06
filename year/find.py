# function to find all years with the most number of people alive
def findYear(file):
    data = []
    with open(file, "rb") as fp:
        for i in fp.readlines():
            temp = i.decode().split(",")
            data.append((int(temp[0]), int(temp[1])))
    # print(*data, sep = '\n')
    result = {}
    max_year = 0
    max_number = 0
    for item in data:
        for i in range(item[0], item[1] + 1):
            if i in result.keys():
                result[i] += 1
                if result[i] > max_number:
                    max_year = i
                    max_number = result[i]
            else:
                result[i] = 1
                if max_number == 0:
                    max_number = 1
    # There might be other answers 
    # with the same amount of people alive
    # We can find those as well
    all_years = []
    for year, number in result.items():
        if number == max_number:
            all_years.append(year)
    all_years.sort()
    return [all_years, max_number]

def test(file):
    print("====================  TEST STARTED ====================")
    print("Reading " + file)
    year, number = findYear(file)
    print("Year(s) with most people alive ({} people):".format(number))    
    for i in year: print(i, sep = '\n')
    print("====================  TEST ENDED ====================")


test("test1.txt")
test("test2.txt")
test("test3.txt")
