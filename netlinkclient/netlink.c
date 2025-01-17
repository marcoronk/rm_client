#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/socket.h>
#include <linux/netlink.h>

#define NETLINK_USER 31
#define MAX_PAYLOAD 1024

int main() {
    struct sockaddr_nl sa;
    int sock;
    struct nlmsghdr *nlh;
    char *msg = "";
    char buffer[MAX_PAYLOAD];

    sock = socket(AF_NETLINK, SOCK_RAW, NETLINK_USER);
    if (sock < 0) {
        perror("Socket error");
        exit(EXIT_FAILURE);
    }

    memset(&sa, 0, sizeof(sa));
    sa.nl_family = AF_NETLINK;
    sa.nl_pid = getpid();


    if (bind(sock, (struct sockaddr*)&sa, sizeof(sa)) < 0) {
        perror("Bind error");
        exit(EXIT_FAILURE);
    }

    

  
    nlh = (struct nlmsghdr*)malloc(NLMSG_SPACE(MAX_PAYLOAD));
    memset(nlh, 0, NLMSG_SPACE(MAX_PAYLOAD));

    nlh->nlmsg_len = NLMSG_SPACE(strlen(msg));
    nlh->nlmsg_type = 0; 
    nlh->nlmsg_flags = 0;
    nlh->nlmsg_seq = 0;
    nlh->nlmsg_pid = getpid();

    memcpy(NLMSG_DATA(nlh), msg, strlen(msg));

   
    if (send(sock, nlh, nlh->nlmsg_len, 0) < 0) {
        perror("Error Send");
        free(nlh);
        exit(EXIT_FAILURE);
    }

    free(nlh);

   
    while (1) {
        nlh = (struct nlmsghdr*)malloc(NLMSG_SPACE(MAX_PAYLOAD));
        memset(nlh, 0, NLMSG_SPACE(MAX_PAYLOAD));

        int len = recv(sock, nlh, NLMSG_SPACE(MAX_PAYLOAD), 0);
        if (len < 0) {
            perror("Error recv message");
            free(nlh);
            exit(EXIT_FAILURE);
        }

        printf("%s\n", (char*)NLMSG_DATA(nlh));
        free(nlh);
    }

    close(sock);
    return 0;
}
