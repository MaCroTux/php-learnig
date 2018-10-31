CREATE TABLE "data_crawler" ("id" VARCHAR PRIMARY KEY UNIQUE, "productId" VARCHAR, "source" VARCHAR, "name" TEXT, "price" VARCHAR, "updateAt" TIMESTAMP, "version" INTEGER);
CREATE TABLE "product" ("id" VARCHAR PRIMARY KEY UNIQUE, "name" VARCHAR, "updateAt" TIMESTAMP);
