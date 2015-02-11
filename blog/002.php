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
        <h2 class="title">k-近邻算法以及算法实例</h2>
    <div class="article">
        <p>机器学习中常常要用到分类算法，在诸多的分类算法中有一种算法名为k-近邻算法，也称为kNN算法。</p>
        <h3>一、kNN算法的工作原理</h3>
        <p>官方解释：存在一个样本数据集，也称作训练样本集，并且样本中每个数据都存在标签，即我们知道样本集中每一数据与所属分类的对应关系，输入没有标签的新数据后，将新数据的每个特征与样本集中的数据对应的特征进行比较，然后算法提取样本集中特征最相似的数据（最近邻）的分类标签。一般来说，我们只选择样本集中前k个最相似的数据，这就是k-近邻算法中k的出处，通常k是不大于20的整数，最后，选择k个最相似的数据中出现次数最多的分类，作为新数据的分类。</p>
        <p>我的理解：k-近邻算法就是根据“新数据的分类取决于它的邻居”进行的，比如邻居中大多数都是退伍军人，那么这个人也极有可能是退伍军人。而算法的目的就是先找出它的邻居，然后分析这几位邻居大多数的分类，极有可能就是它本省的分类。</p>
        <h3>二、适用情况</h3>
        <p>优点：精度高，对异常数据不敏感（你的类别是由邻居中的大多数决定的，一个异常邻居并不能影响太大），无数据输入假定；</p>
        <p>缺点：计算发杂度高（需要计算新的数据点与样本集中每个数据的“距离”，以判断是否是前k个邻居），空间复杂度高（巨大的矩阵）；</p>
        <p>适用数据范围：数值型（目标变量可以从无限的数值集合中取值）和标称型（目标变量只有在有限目标集中取值）。</p>
        <h3>三、算法实例及讲解</h3>
        <p>例子中的案例摘《机器学习实战》一书中的，代码例子是用python编写的（需要numpy库），不过重在算法，只要算法明白了，用其他语言都是可以写出来的：</p>
        <p><b>海伦一直使用在线约会网站寻找合适自己的约会对象。尽管约会网站会推荐不同的人选，但她没有从中找到喜欢的人。经过一番总结，她发现曾交往过三种类型的人：1.不喜欢的人（以下简称1）；2.魅力一般的人（以下简称2） ；3.极具魅力的人（以下简称3）</b></p>
        <p><b>尽管发现了上述规律，但海伦依然无法将约会网站推荐的匹配对象归入恰当的分类。她觉得可以在周一到周五约会哪些魅力一般的人，而周末则更喜欢与那些极具魅力的人为伴。海伦希望我们的分类软件可以更好的帮助她将匹配对象划分到确切的分类中。此外海伦还收集了一些约会网站未曾记录的数据信息，她认为这些数据更有助于匹配对象的归类。</b></p>
        <p>我们先提取一下这个案例的目标：根据一些数据信息，对指定人选进行分类（1或2或3）。为了使用kNN算法达到这个目标，我们需要哪些信息？前面提到过，就是需要样本数据，仔细阅读我们发现，这些样本数据就是<b>“海伦还收集了一些约会网站未曾记录的数据信息”。好的，下面我们就开始吧！</b></p>
        <h4>----1.收集数据</h4>
        <p>海伦收集的数据是记录一个人的三个特征：每年获得的飞行常客里程数；玩视频游戏所消耗的时间百分比；每周消费的冰淇淋公升数。数据是txt格式文件，如下图，前三列依次是三个特征，第四列是分类（1：不喜欢的人，2：魅力一般的人，3：极具魅力的人），每一行代表一个人。</p>
        <p>数据文档的下载链接是：<a href="http://pan.baidu.com/s/1jG7n4hS">http://pan.baidu.com/s/1jG7n4hS</a></p>
        <p><img src="../resource/002-01.png"/></p>
        <h4>----2.准备数据</h4>
        <p>何为准备数据？之前收集到了数据，放到了txt格式的文档中了，看起来也比较规整，但是计算机并不认识啊。计算机需要从txt文档中读取数据，并把数据进行格式化，也就是说存到矩阵中，用矩阵来承装这些数据，这样才能使用计算机处理。</p>
        <p>需要两个矩阵：一个承装三个特征数据，一个承装对应的分类。于是，我们定义一个函数，函数的输入时数据文档（txt格式），输出为两个矩阵。</p>
        <p>代码如下：</p>
        <pre>
        def file2matrix(filename):
            fr = open(filename)
            numberOfLines = len(fr.readlines())
            returnMat = zeros((numberOfLines, 3))
            classLabelVector = []
            fr = open(filename)
            index = 0
            for line in fr.readlines():
                line = line.strip()
                listFromLine = line.split('\t')
                returnMat[index, :] = listFromLine[0:3]
                classLabelVector.append(int(listFromLine[-1]))
                index += 1
            return returnMat, classLabelVector
        </pre>
        <p>简要解读代码：首先打开文件，读取文件的行数，然后初始化之后要返回的两个矩阵（returnMat、classLabelsVector），然后进入循环，将每行的数据各就各位分配给returnMat和classLabelsVector。</p>
        <h4>----3.设计算法分析数据</h4>
        <p>k-近邻算法的目的就是找到新数据的前k个邻居，然后根据邻居的分类来确定该数据的分类。</p>
        <p>首先要解决的问题，就是什么是邻居？当然就是“距离”近的了，不同人的距离怎么确定？这个有点抽象，不过我们有每个人的3个特征数据。每个人可以使用这三个特征数据来代替这个人——三维点。比如样本的第一个人就可以用（40920， 8.326976， 0.953952）来代替，并且他的分类是3。那么此时的距离就是点的距离：</p>
        <p>A点(x1, x2, x3)，B点(y1, y2, y3)，这两个点的距离就是：(x1-y1)^2+(x2-y2)^2+(x3-y3)^2的平方根。求出新数据与样本中每个点的距离，然后进行从小到大排序，前k位的就是k-近邻，然后看看这k位近邻中占得最多的分类是什么，也就获得了最终的答案。</p>
        <p>这个处理过程也是放到一个函数里的，代码如下：</p>
        <pre>
        def classify0(inX, dataSet, labels, k):
            dataSetSize = dataSet.shape[0]
            diffMat = tile(inX, (dataSetSize,1)) - dataSet
            sqDiffMat = diffMat**2
            sqDistances = sqDiffMat.sum(axis=1)
            distances = sqDistances**0.5
            sortedDistIndicies = distances.argsort()
            classCount={}
            for i in range(k):
                voteIlabel = labels[sortedDistIndicies[i]]
                classCount[voteIlabel] = classCount.get(voteIlabel,0) + 1
            sortedClassCount = sorted(classCount.iteritems(),key=operator.itemgetter(1), reverse=True)
            return sortedClassCount[0][0]
        </pre>
        <p>简要解读代码：该函数的4个参数分别为新数据的三个特征inX、样本数据特征集（上一个函数的返回值）、样本数据分类（上一个函数的返回值）、k，函数返回位新数据的分类。第二行dataSetSize获取特征集矩阵的行数，第三行为新数据与样本各个数据的差值，第四行取差值去平方，之后就是再取和，然后平方根。代码中使用的排序函数都是python自带的。</p>
        <p>好了，现在我们可以分析数据了，不过，有一点不知道大家有没有注意，我们回到那个数据集，第一列代表的特征数值远远大于其他两项特征，这样在求距离的公式中就会占很大的比重，致使两点的距离很大程度上取决于这个特征，这当然是不公平的，我们需要的三个特征都均平地决定距离，所以我们要对数据进行处理，希望处理之后既不影响相对大小又可以不失公平：</p>
        <p><img src="../resource/002-02.png" /></p>
        <p>这种方法叫做，归一化数值，通过这种方法可以把每一列的取值范围划到0~1或-1~1:，处理的公式为：</p>
        <p>newValue = (oldValue - min)/(max - min)</p>
        <p>归一化数值的函数代码为</p>
        <pre>
        def autoNorm(dataSet):
            minVals = dataSet.min(0)
            maxVals = dataSet.max(0)
            ranges = maxVals - minVals
            normDataSet = zeros(shape(dataSet))
            m = dataSet.shape[0]
            normDataSet = dataSet - tile(minVals, (m, 1))
            normDataSet = normDataSet / tile(ranges, (m, 1))
            return normDataSet, ranges, minVals
        </pre>
        <h4>---4.测试算法</h4>
        <p>经过了格式化数据、归一化数值，同时我们也已经完成kNN核心算法的函数，现在可以测试了，测试代码为：</p>
        <pre>
        def datingClassTest():
            hoRatio = 0.10
            datingDataMat, datingLabels = file2matrix('datingTestSet.txt')
            normMat, ranges, minVals = autoNorm(datingDataMat)
            m = normMat.shape[0]
            numTestVecs = int(m * hoRatio)
            errorCount = 0.0
            for i in range(numTestVecs):
                classifierResult = classify0(normMat[i, :], normMat[numTestVecs:m, :], datingLabels[numTestVecs:m], 3)
                print "the classifier came back with: %d, the real answer is: %d" % (classifierResult, datingLabels[i])
                if (classifierResult != datingLabels[i]): errorCount += 1.0
            print "the total error rate is: %f" % (errorCount / float(numTestVecs))
        </pre>
        <p>通过测试代码我们可以在回忆一下这个例子的整体过程</p>
        <ul>
            <li>读取txt文件，提取里面的数据到datingDataMat、datingLabels；</li>
            <li>归一化数据，得到归一化的数据矩阵；</li>
            <li>测试数据不止一个，这里需要一个循环，依次对每个测试数据进行分类。</li>
        </ul>
        <p>代码中大家可能不太明白hoRatio是什么。注意，这里的测试数据并不是另外一批数据而是之前的数据集里的一部分，这样我们可以把算法得到的结果和原本的分类进行对比，查看算法的准确度。在这里，海伦提供的数据集又1000行，我们把前100行作为测试数据，后900行作为样本数据集，现在大家应该可以明白hoRatio是什么了吧。</p>
        <p>整体的代码：</p>
        <pre>
        from numpy import *
        import operator

        def classify0(inX, dataSet, labels, k):
            dataSetSize = dataSet.shape[0]
            diffMat = tile(inX, (dataSetSize,1)) - dataSet
            sqDiffMat = diffMat**2
            sqDistances = sqDiffMat.sum(axis=1)
            distances = sqDistances**0.5
            sortedDistIndicies = distances.argsort()
            classCount={}
            for i in range(k):
                voteIlabel = labels[sortedDistIndicies[i]]
                classCount[voteIlabel] = classCount.get(voteIlabel,0) + 1
            sortedClassCount = sorted(classCount.iteritems(),key=operator.itemgetter(1), reverse=True)
            return sortedClassCount[0][0]

        def file2matrix(filename):
            fr = open(filename)
            numberOfLines = len(fr.readlines())
            returnMat = zeros((numberOfLines, 3))
            classLabelVector = []
            fr = open(filename)
            index = 0
            for line in fr.readlines():
                line = line.strip()
                listFromLine = line.split('\t')
                returnMat[index, :] = listFromLine[0:3]
                classLabelVector.append(int(listFromLine[-1]))
                index += 1
            return returnMat, classLabelVector

        def autoNorm(dataSet):
            minVals = dataSet.min(0)
            maxVals = dataSet.max(0)
            ranges = maxVals - minVals
            normDataSet = zeros(shape(dataSet))
            m = dataSet.shape[0]
            normDataSet = dataSet - tile(minVals, (m, 1))
            normDataSet = normDataSet / tile(ranges, (m, 1))
            return normDataSet, ranges, minVals

        def datingClassTest():
            hoRatio = 0.10
            datingDataMat, datingLabels = file2matrix('datingTestSet.txt')
            normMat, ranges, minVals = autoNorm(datingDataMat)
            m = normMat.shape[0]
            numTestVecs = int(m * hoRatio)
            errorCount = 0.0
            for i in range(numTestVecs):
                classifierResult = classify0(normMat[i, :], normMat[numTestVecs:m, :], datingLabels[numTestVecs:m], 3)
                print "the classifier came back with: %d, the real answer is: %d" % (classifierResult, datingLabels[i])
                if (classifierResult != datingLabels[i]): errorCount += 1.0
            print "the total error rate is: %f" % (errorCount / float(numTestVecs))
        </pre>
        <p>运行一下代码，这里我使用的是ipython：</p>
        <img src="../resource/002-03.png" />
        <img src="../resource/002-04.png" />
        <p>最后的错误率为0.05</p>
    </div>
    <div class="footer">
    天涯云水-CooFoo空间 email:jtianwen2014@163.com
    </div>
    </body>
</html>
