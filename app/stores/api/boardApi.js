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
};
