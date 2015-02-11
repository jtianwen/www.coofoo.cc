<!DOCTYPE html>
<html>
    <head>
        <title>天涯云水路漫漫</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../css/mystyle.css" />
    </head>
    <body>
    <div class="header">
        <h1>天涯云水：coofoo博客</h1>
    </div>
        <h2 class="title">k-近邻算法应用之手写数字识别</h2>
    <div class="article">
        <p>上篇文章简要介绍了k-近邻算法的算法原理以及一个简单的例子，今天再向大家介绍一个简单的应用，因为使用的原理大体差不多，就没有没有过多的解释。</p>
        <p>为了具有说明性，把手写数字的图像转换为txt文件，如下图所示（三个图分别为5、6、8）：</p>
        <img src="http://images.cnitblog.com/blog/706575/201501/301242379412134.png" />
        <img src="http://images.cnitblog.com/blog/706575/201501/301242499411200.png" />
        <img src="http://images.cnitblog.com/blog/706575/201501/301242560031720.png" />
        <p>要使用k-近邻算法，需要有足够的样本数据和测试数据，我放到了两个文件夹里（trainingDigits和testDigits），可以在这里（<a href="http://pan.baid    u.com/s/1i3osO7N">http://pan.baidu.com/s/1i3osO7N</a>）下载使用</p>
        <p>这里，每个数字有32X32个0或1，可以认为是一个维度为1024的点，也就是对这种点运用kNN算法，这里只附上手写数字的测试函数代码，代码和总需要的其他函数都在上一篇文章中，另外，需要注意的是因为要获取文件类列表，需要在文件中的头部再加上from os import listdir</p>
        <pre>
        def handwritingClassTest():
            hwLabels = []
            trainingFileList = listdir('trainingDigits')
            m = len(trainingFileList)
            trainingMat = zeros((m, 1024))
            for i in range(m):
                fileNameStr = trainingFileList[i]
                fileStr = fileNameStr.split('.')[0]
                classNumStr = int(fileStr.split('_')[0])
                hwLabels.append(classNumStr)
                trainingMat[i, :] = img2vector('trainingDigits/%s' % fileNameStr )
            testFileList = listdir('testDigits')
            errorCount = 0.0
            mTest = len(testFileList)
            for i in range(mTest):
                fileNameStr = testFileList[i]
                fileStr = fileNameStr.split('.')[0]
                classNumStr = int(fileStr.split('_')[0])
                vectorUnderTest = img2vector('testDigits/%s' % fileNameStr)
                classifierResult = classify0(vectorUnderTest, trainingMat, hwLabels, 3)
                print "the classifier came back with: %d, the real answer is: %d" % (classifierResult, classNumStr)
                if(classifierResult != classNumStr): errorCount += 1.0
            print "\nthe total number of errors is: %d" % errorCount
            print "\nthe total error rate is: %f" % (errorCount / float(mTest))
        </pre>
        <p>测试结果如下图：</p>
        <img src="http://images.cnitblog.com/blog/706575/201501/301307347228576.png" />
        <img src="http://images.cnitblog.com/blog/706575/201501/301309377068982.png" />
    </div>
    <div class="footer">
    天涯云水-CooFoo空间 email:jtianwen2014@163.com
    </div>
    </body>
</html>
