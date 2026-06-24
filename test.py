class Solution:
    def countAndSay(self, n: int) -> str:
        if n == 1:
            return '1'
        
        result = '11'
        
        for i in range(n - 2):      
            temp = result[0]
            count = 1
            tempString = ''
            
            for j in range(1, len(result)):
                if result[j] == temp:   
                    count += 1
                else:
                    tempString += str(count) + temp
                    temp = result[j]
                    count = 1
            
            tempString += str(count) + temp  
            result = tempString
        
        return result

sol = Solution()
print(sol.countAndSay(4))  