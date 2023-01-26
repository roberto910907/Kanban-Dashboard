export default {
  async getBoardList() {
    const query = gql`
      query getBoards {
        boards {
          data {
            id
            uuid
            name
          }
        }
      }
    `;

    return useQuery(query);
  },

  async createBoard(newBoard) {
    const query = gql`
        mutation createBoard {
            createBoard(name: "${newBoard.name}", is_private: ${newBoard.is_private}) {
                id
                uuid
                name
                is_private
                created_at
            }
        }
    `;

    return useMutation(query);
  },

  deleteBoard(boardId) {
    const query = gql`
        mutation deleteBoard {
            deleteBoard(id: "${boardId}") {
                uuid
            }
        }
    `;

    return useMutation(query);
  },
};
