#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/wait.h>


int main()
{
    while (1) {
        char buf[10];
        int status;
        printf("Wybierz jedno z podanych poleceñ [d,s,c,t]:\n");
        fgets(buf, sizeof(buf), stdin);
		pid_t pid = fork();
		if (pid==0) {
			if (buf[0]=='d') {
				printf("Potomek pid=%d\n", getpid());
                     		execlp("date", "date", NULL);
				exit(0);
			}
			if (buf[0]=='t') {
				printf("Potomek pid=%d\n", getpid());
                        	execlp("xterm", "xterm", NULL);
				exit(0);
			}
			if (buf[0]=='c') {
				printf("Potomek pid=%d\n", getpid());
                        	execlp("xclock", "xclock", NULL);
				exit(0);
			}
			if (buf[0]=='s') {
				printf("Potomek pid=%d\n", getpid());
                        	execlp("sh", "sh", NULL);
				exit(0);
			}
		}
             	if (buf[0] == 'd' || buf[0] == 's') {
                        wait(NULL);
                }
               	if (buf[0] == 'c' || buf[0] == 't'){
                     	waitpid(pid, &status, WNOHANG);
                }
                printf("Rodzic po utworzeniu potomka.\n");
        }
}
