DBGFLAGS ?= -g -Wall
DBGBUILDFLAGS ?= -DDEBUG_ON

SRC ?= netlink.c
OBJ ?= netlink





default:
	$(CROSS_COMPILE) $(CC) $(DBGFLAGS) $(LDFLAGS) -o $(OBJ) $(SRC)
all:
	$(CROSS_COMPILE) $(CC) $(DBGFLAGS) $(LDFLAGS) -o $(OBJ) $(SRC)
debug:
	$(CROSS_COMPILE) $(CC) $(DBGFLAGS) $(LDFLAGS) $(DBGBUILDFLAGS) -o $(OBJ) $(SRC)

clean:
	rm -f *.o $(OBJ)	